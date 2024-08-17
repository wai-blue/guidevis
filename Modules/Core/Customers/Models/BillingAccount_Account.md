# Model Contacts/BillingAccount_Account

## Introduction

## Constants

## Properties

| Property        | Value                     |
| :-------------- | :------------------------ |
| isJunctionTable | TRUE                      |
| sqlName         | billing_accounts_accounts |
| lookupSqlValue  |                           |

## Data Scructure

| Column             | Title           | ADIOS Type | Length | Required |
| ------------------ | --------------- | ---------- | ------ | -------- |
| id                 | ID              | int        |        | TRUE     |
| id_billing_account | Billing Account | int        |        | TRUE     |
| id_account         | Account         | int        |        | TRUE     |

## ADIOS parameters

## Foreign Keys

| Column             | Model                                                             | Relation | OnUpdate | OnDelete |
| ------------------ | ----------------------------------------------------------------- | -------- | -------- | -------- |
| id_billing_account | [Modules\Core\Customers\Models\BillingAccount](BillingAccount.md) | 1:N      | Cascade  | Restrict |
| id_account         | [Modules\Core\Customers\Models\Account](Account.md)               | 1:N      | Cascade  | Restrict |

## Indexes

| Name               |  Type   |         Column + Order |
| :----------------- | :-----: | ---------------------: |
| id                 | PRIMARY |                 id ASC |
| id_account         | PRIMARY |         id_account ASC |
| id_billing_account | PRIMARY | id_billing_account ASC |
