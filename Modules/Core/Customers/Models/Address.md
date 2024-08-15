# Model Customers/Address

## Introduction

Zoznam adries použitých v systéme.

## Constants

## Properties

| Property        | Value                  | notes         |
| :-------------- | :--------------------- | ------------- |
| isJunctionTable | FALSE                  |               |
| storeRecordInfo | FALSE                  |               |
| sqlName         | cer_address            |               |
| lookupSqlValue  | street                 | overiť lookup |

## Data Scructure

| Column      | Title       | ADIOS Type | Length | Required |
| ----------- | ----------- | ---------- | ------ | -------- |
| id_address  | ID          | int        |        | TRUE     |
| street      | Street      | varchar    |        | TRUE     |
| postal_code | Postal code | varchar    |        | TRUE     |
| city        | City        | varchar    |        | TRUE     |
| country     | Country     | varchar    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

## Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
