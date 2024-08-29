# Model Customers/Company

## Introduction

Zoznam firiem, ktoré existujú v systéme.

## Constants

## Properties

| Property        | Value                  |
| :-------------- | :--------------------- |
| isJunctionTable | FALSE                  |
| sqlName         | companies              |
| urlBase         | core/customers/company |
| lookupSqlValue  | {%TABLE%}.name         |

## Data Scructure

| Column        | Title         | ADIOS Type | Length | Required |
| ------------- | ------------- | ---------- | ------ | -------- |
| id            | ID            | int        |        | TRUE     |
| id_country    | Country       | lookup     |        | TRUE     |
| company_id    | Company ID    | varchar    |        | TRUE     |
| name          | Company Name  | varchar    |        | TRUE     |
| postal_code   | Postal code   | varchar    |        | TRUE     |
| street_line_1 | Street line 1 | varchar    |        | TRUE     |
| street_line_2 | Street line 2 | varchar    |        | FALSE    |
| city          | City          | varchar    |        | TRUE     |
| region        | Region        | varchar    |        | TRUE     |
| tax_id        | Tax ID        | varchar    |        | FALSE    |
| vat_id        | Vat ID        | varchar    |        | FALSE    |
| note          | Note          | text       |        | FALSE    |
| is_active     | Active        | boolean    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

| Column     | Model                                               | Relation | OnUpdate | OnDelete |
| ---------- | --------------------------------------------------- | -------- | -------- | -------- |
| id_country | [Modules\Core\Customers\Models\Country](Country.md) | 1:1      | Cascade  | Restrict |

## Indexes

| Name       |  Type   | Column + Order |
| :--------- | :-----: | -------------: |
| id         | PRIMARY |         id ASC |
| company_id | UNIQUE  | company_id ASC |
