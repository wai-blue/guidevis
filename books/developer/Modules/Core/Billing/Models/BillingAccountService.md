# Model Contacts/BillingAccountService

## Introduction

## Constants

## Properties

| Property        | Value            |
| :-------------- | :--------------- |
| isJunctionTable | TRUE             |
| sqlName         | billing_accounts |
| lookupSqlValue  | {%TABLE%}.id     |

## Data Scructure

| Column             | Title   | ADIOS Type | Length | Required |
| ------------------ | ------- | ---------- | ------ | -------- |
| id                 | ID      | int        |        | TRUE     |
| id_service         | Service | lookup     |        | TRUE     |
| id_billing_account | Account | lookup     |        | TRUE     |

## ADIOS parameters

## Foreign Keys

| Column             | Model                                                           | Relation | OnUpdate | OnDelete |
| ------------------ | --------------------------------------------------------------- | -------- | -------- | -------- |
| id_billing_account | [Modules\Core\Billing\Models\BillingAccount](BillingAccount.md) | 1:N      | Cascade  | Restrict |
| id_service         | [Modules\Core\Services\Models\Service](Service.md)              | 1:N      | Cascade  | Restrict |

## Indexes

| Name               |  Type   |         Column + Order |
| :----------------- | :-----: | ---------------------: |
| id                 | PRIMARY |                 id ASC |
| id_service         | PRIMARY |         id_service ASC |
| id_billing_account | PRIMARY | id_billing_account ASC |
