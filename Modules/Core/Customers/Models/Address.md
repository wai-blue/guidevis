# Model Customers/Address

## Introduction

Zoznam adries.

## Constants

## Properties

| Property        | Value                  |
| :-------------- | :--------------------- |
| isJunctionTable | FALSE                  |
| storeRecordInfo | FALSE                  |
| sqlName         | cer_address            |
| urlBase         | core/customers/address |
| lookupSqlValue  | street                 |

<strong style="color:orange">
overiť lookup value
</strong>

## Data Scructure

| Column            | Title        | ADIOS Type | Length | Required |
| ----------------- | ------------ | ---------- | ------ | -------- |
| id                | ID           | int        | 8      | TRUE     |
| street            | Street       | varchar    |        | TRUE     |
| postal_code       | Postal code  | varchar    |        | TRUE     |
| city              | City         | varchar    |        | TRUE     |
| country           | Country      | varchar    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

## Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |

