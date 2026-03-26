# Revest_Contact Module

## Overview

The **Revest_Contact** module provides a custom REST API to submit contact form data, store it in the database, display it in the Magento admin grid, and notify configured email recipients.

---

## Features

* Custom REST API for contact form submission
* Stores data in `revest_contact` table
* Admin grid to view submitted queries
* Admin configuration for email recipients (comma-separated)
* Email notification on new submission

---

## REST API

### Endpoint

```
POST /rest/V1/revest/contact
```

### Request Body (JSON)

```json
{
  "name": "Ram",
  "email": "ram@test.com",
  "telephone": "1234",
  "comment": "Test message"
}
```

### Response

```
true
```

---

## Admin Configuration

Navigate to:

```
Stores → Configuration → Revest → Contact Settings
```

### Fields

**Email Recipients**

* Enter comma-separated email addresses

```
ramendra.pati@gmail.com
```

---

## Admin Grid

Navigate to:

```
Admin → Content → Contact Request
```

### Columns:

* ID
* Name
* Email
* Message
* Created At

---

## Database

### Table: `revest_contact`

| Column     | Type      |
| ---------- | --------- |
| entity_id  | int (PK)  |
| name       | text      |
| email      | text      |
| telephone  | text      |
| comment    | text      |
| created_at | timestamp |

---

## Email Notification

* Triggered after successful API submission
* Sent to configured recipients
* Uses Magento email template:

```
revest_contact_email_template
```

---

## Installation

1. Place module in:

```
app/code/Revest/Contact
```

2. Run commands:

```
php bin/magento setup:upgrade
php bin/magento cache:flush
php bin/magento setup:di:compile
```

* Ensure email sender is configured:

```
Stores → Configuration → General → Store Email Addresses
-
