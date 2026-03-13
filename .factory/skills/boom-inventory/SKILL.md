---
name: boom-inventory
description: >
  Domain expertise for Boom Warehouse inventory management. Use this skill
  whenever building features that touch products, stock levels, orders,
  warehouse operations, or the Acima lease-to-own integration.
  Covers: multi-location inventory, condition grading, stock reservation,
  barcode operations, and refurbished electronics pricing.
---

# Boom Warehouse Inventory Domain

## Business Model
Boom Warehouse is a Cleveland-area warehouse retailer selling refurbished and new
electronics, appliances, TVs, computers, furniture, and household goods. Two
physical locations plus an e-commerce store on boomwarehouse.com.

### Locations
| ID | Name | Address | Role |
|----|------|---------|------|
| loc_renaissance | Renaissance Pkwy | 4554 Renaissance Pkwy, Warrensville Heights, OH 44128 | Primary warehouse + showroom |
| loc_emery | Emery Rd | 26055 Emery Rd B-1, Cleveland, OH | Secondary location |

### Product Conditions
| Condition | Description | Typical Discount from MSRP |
|-----------|-------------|---------------------------|
| `new` | Factory sealed, full warranty | 20-40% off |
| `refurbished` | Tested, cleaned, functional. May have cosmetic wear. | 40-60% off |
| `open_box` | Opened/returned, complete, functional | 30-50% off |

### Product Categories (hierarchical)
```
Electronics
├── TVs (Smart TVs, LED TVs, Monitors)
├── Computers (Laptops, Desktops, Tablets)
├── Audio (Speakers, Headphones, Soundbars)
└── Accessories
Appliances
├── Large (Refrigerators, Freezers, Washers)
├── Small (Microwaves, Air Fryers, Coffee Makers)
└── Parts & Accessories
Furniture
├── Office (Desks, Chairs, Bookshelves)
└── Home (Tables, Storage, Shelving)
Household
├── Kitchen
├── Bathroom
└── Cleaning
```

## Stock Management Rules

### Multi-Location Stock
- Each product has independent stock levels per location
- Online orders pull from the location with highest available quantity
- Stock transfers between locations are tracked as inventory_transactions
- Total available = sum(quantity - reserved_quantity) across all locations

### Stock Reservation
- When a customer adds to cart and reaches checkout, stock is NOT reserved
- Stock is reserved ONLY when order is created (payment initiated)
- Reservation TTL: 15 minutes
- If payment not completed in 15 minutes, reservation is released
- Cron job runs every minute to release expired reservations
- Race condition protection: use PostgreSQL SELECT FOR UPDATE on stock rows

### Reorder Points
- Each product/location combo has a configurable reorder_point
- When quantity <= reorder_point, fire webhook to n8n
- n8n sends email + Slack notification to warehouse manager
- Default reorder_point: 3 for electronics, 2 for appliances, 5 for accessories

### Inventory Transactions
Every stock change is logged as an inventory_transaction:
| Type | Description | quantity_change |
|------|-------------|-----------------|
| `received` | Item scanned into warehouse | + |
| `sold` | Order fulfilled | - |
| `adjusted` | Manual count correction | +/- |
| `transferred` | Moved between locations | - at source, + at dest |
| `reserved` | Held for checkout | - (from available) |
| `released` | Reservation expired | + (back to available) |
| `returned` | Customer return | + |

## Payment Integration

### Stripe (Primary)
Standard Stripe Checkout / Payment Intents for credit card payments.

### Acima Lease-to-Own
- Customer selects "Lease-to-Own" at checkout
- POST to Acima API with customer info + order total
- Acima returns approval/denial + lease terms
- On approval: create order with payment_method=acima, store acima_lease_id
- Acima handles ongoing payment collection directly with customer
- Boom Warehouse receives full payment from Acima (minus Acima's fee)
- Max lease amount: $5,000

### In-Store / Cash
- Staff creates order via admin dashboard
- payment_method=in_store or payment_method=cash
- No external payment processing needed

## Data Model

### Products
```sql
products (
  id UUID PK DEFAULT gen_random_uuid(),
  sku VARCHAR(50) UNIQUE NOT NULL,
  name VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NOT NULL,
  description TEXT,
  category_id UUID FK -> categories,
  brand VARCHAR(100),
  model_number VARCHAR(100),
  condition product_condition NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  compare_at_price DECIMAL(10,2),
  cost DECIMAL(10,2),
  weight_lbs DECIMAL(6,2),
  dimensions JSONB,
  images JSONB NOT NULL DEFAULT '[]',
  is_active BOOLEAN DEFAULT true,
  is_featured BOOLEAN DEFAULT false,
  meta_title VARCHAR(255),
  meta_description TEXT,
  created_at TIMESTAMPTZ DEFAULT now(),
  updated_at TIMESTAMPTZ DEFAULT now(),
  deleted_at TIMESTAMPTZ
)
```

### Stock Levels
```sql
stock_levels (
  product_id UUID FK -> products,
  location_id UUID FK -> locations,
  quantity INTEGER NOT NULL DEFAULT 0,
  reserved_quantity INTEGER NOT NULL DEFAULT 0,
  reorder_point INTEGER NOT NULL DEFAULT 3,
  last_counted_at TIMESTAMPTZ,
  PRIMARY KEY (product_id, location_id)
)
```

### Orders
```sql
orders (
  id UUID PK DEFAULT gen_random_uuid(),
  order_number VARCHAR(20) UNIQUE NOT NULL,
  customer_id UUID FK -> customers,
  shipping_address_id UUID FK -> addresses,
  status order_status NOT NULL DEFAULT 'pending',
  payment_method payment_method NOT NULL,
  stripe_payment_intent_id VARCHAR(255),
  acima_lease_id VARCHAR(255),
  subtotal DECIMAL(10,2) NOT NULL,
  tax_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  shipping_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  total DECIMAL(10,2) NOT NULL,
  notes TEXT,
  fulfilled_at TIMESTAMPTZ,
  shipped_at TIMESTAMPTZ,
  created_at TIMESTAMPTZ DEFAULT now(),
  updated_at TIMESTAMPTZ DEFAULT now()
)
```

### Meilisearch Sync
- Searchable: name, description, brand, model_number, category.name
- Filterable: price, condition, category_id, is_active, in_stock (computed boolean)
- Sortable: price, created_at, name
- Synonyms: {tv: [television], fridge: [refrigerator], pc: [computer, desktop]}
