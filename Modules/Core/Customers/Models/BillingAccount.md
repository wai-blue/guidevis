# Model Contacts/BillingAccount

## Introduction

## Constants

## Properties

| Property        | Value               |
| :-------------- | :------------------ |
| isJunctionTable | FALSE               |
| storeRecordInfo | FALSE               |
| sqlName         | cer_billing_account |
| lookupSqlValue  | id_billing_account  |

## Data Scructure

| Column             | Title                | ADIOS Type | Length | Required |
| ------------------ | -------------------- | ---------- | ------ | -------- |
| id_billing_account | ID                   | int        |        | TRUE     |
| name               | Billing Account Name | varchar    |        | TRUE     |
| dic_tax_id         | TAX ID               | varchar    |        | TRUE     |
| icdph_vat_id       | VAT ID               | varchar    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

## Indexes

| Name               |  Type   |         Column + Order |
| :----------------- | :-----: | ---------------------: |
| id_billing_account | PRIMARY | id_billing_account ASC |
