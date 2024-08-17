# Model Contacts/BillingAccount

## Introduction

## Constants

## Properties

| Property        | Value                        |
| :-------------- | :--------------------------- |
| isJunctionTable | FALSE                        |
| sqlName         | billing_accounts             |
| lookupSqlValue  | {%TABLE%}.id_billing_account |

## Data Scructure

| Column       | Title                | ADIOS Type | Length | Required |
| ------------ | -------------------- | ---------- | ------ | -------- |
| id           | ID                   | int        |        | TRUE     |
| name         | Billing Account Name | varchar    |        | TRUE     |
| dic_tax_id   | TAX ID               | varchar    |        | TRUE     |
| icdph_vat_id | VAT ID               | varchar    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

## Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
