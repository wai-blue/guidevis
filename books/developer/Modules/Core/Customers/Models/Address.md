# Model Customers/Address

## Introduction

Zoznam adries použitých v systéme.

## Constants

## Properties

| Property        | Value                            |
| :-------------- | :------------------------------- |
| isJunctionTable | FALSE                            |
| sqlName         | persons_addresses                |
| urlBase         | core/customers/persons-addresses |
| lookupSqlValue  | {%TABLE%}.street                 |

## Data Scructure

| Column      | Title       | ADIOS Type | Length | Required |
| ----------- | ----------- | ---------- | ------ | -------- |
| id          | ID          | int        |        | TRUE     |
| id_person   | Person      | lookup     |        | TRUE     |
| street      | Street      | varchar    |        | TRUE     |
| postal_code | Postal code | varchar    |        | TRUE     |
| region      | Region      | varchar    |        | TRUE     |
| city        | City        | varchar    |        | TRUE     |
| country     | Country     | varchar    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

## Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
