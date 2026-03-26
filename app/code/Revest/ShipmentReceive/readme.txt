# Revest_ShipmentReceive Module

## Overview

The **Revest_ShipmentReceive** module adds a custom radio button field **“Shipment Receive”** to the checkout shipping address form.
The selected value is saved to the quote and order, and displayed in the Magento Admin under Order and Shipment views.

---

## Features

* Adds **Shipment Receive** field on checkout (Shipping Address step)
* Options:

  * Home
  * Work
  * Other
* Saves value in:

  * `quote` table
  * `sales_order` table
* Displays value in:

  * Admin **Order View**
  * Admin **Shipment View**

---

## Checkout Field

### Label:

```
Shipment Receive
```

### Options:

```
Home
Work
Other
```

### Field Code:

```
shipmentReceive
```

---

## Database Changes

### Tables Updated:

#### `quote`

| Column           | Type        |
| ---------------- | ----------- |
| shipment_receive | varchar(50) |

#### `sales_order`

| Column           | Type        |
| ---------------- | ----------- |
| shipment_receive | varchar(50) |

---

## Data Flow

1. Customer selects **Shipment Receive** option on checkout page
2. Value is stored in **quote address (extension attributes)**
3. Saved into **quote table**
4. During order placement, value is copied to **sales_order table**
5. Displayed in Admin panels

---

## Admin Panel Display

### Order View

```
Sales → Orders → View Order
```

Displays:

```
Shipment Receive: Home / Work / Other
```

---

### Shipment View

```
Sales → Orders → Shipments → View Shipment
```

Displays:

```
Shipment Receive: Home / Work / Other
```

