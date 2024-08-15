# Model Contacts/BillingAccount_Account

## Introduction

## Constants

## Properties

| Property        | Value                       |
| :-------------- | :-------------------------- |
| isJunctionTable | FALSE                       |
| storeRecordInfo | FALSE                       |
| sqlName         | cer_billing_account_account |
| lookupSqlValue  |                             |

## Data Scructure

| Column             | Title              | ADIOS Type | Length | Required |
| ------------------ | ------------------ | ---------- | ------ | -------- |
| id_billing_account | ID Billing Account | int        |        | TRUE     |
| id_account         | ID Account         | int        |        | TRUE     |

## ADIOS parameters

## Foreign Keys

| Column             | Model                                                             | Relation | OnUpdate | OnDelete |
| ------------------ | ----------------------------------------------------------------- | -------- | -------- | -------- |
| id_billing_account | [Modules\Core\Customers\Models\BillingAccount](BillingAccount.md) | 1:N      | Cascade  | Restrict |
| id_account         | [Modules\Core\Customers\Models\Account](Account.md)               | 1:N      | Cascade  | Restrict |

## Indexes

| Name               |  Type   |         Column + Order |
| :----------------- | :-----: | ---------------------: |
| id_account         | PRIMARY |         id_account ASC |
| id_billing_account | PRIMARY | id_billing_account ASC |
