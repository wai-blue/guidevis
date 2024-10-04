# Model Customers/CompanyTag

## Introduction

## Constants

## Properties

| Property        | Value                  |
| :-------------- | :--------------------- |
| isJunctionTable | FALSE                  |
| sqlName         |                        |
| urlBase         | core/customers/company |
| lookupSqlValue  | {%TABLE%}.id_tag       |

## Data Scructure

| Column     | Title   | ADIOS Type | Length | Required |
| ---------- | ------- | ---------- | ------ | -------- |
| id_tag     | ID      | lookup     |        | TRUE     |
| id_company | Company | lookup     |        | TRUE     |

### ADIOS parameters

### Foreign Keys

| Column     | Model                                               | Relation | OnUpdate | OnDelete |
| ---------- | --------------------------------------------------- | -------- | -------- | -------- |
| id_company | [Modules\Core\Customers\Models\Company](Company.md) | 1:N      | Cascade  | Restrict |
| id_tag     | [Modules\Core\Customers\Models\Tag](Tag.md)         | 1:N      | Cascade  | Restrict |

### Indexes

| Name   |  Type   | Column + Order |
| :----- | :-----: | -------------: |
| id_tag | PRIMARY |         id ASC |
