# Model Customers/PersonTag

## Introduction

## Constants

## Properties

| Property        | Value                  |
| :-------------- | :--------------------- |
| isJunctionTable | FALSE                  |
| sqlName         |                        |
| urlBase         | core/customers/persons |
| lookupSqlValue  | {%TABLE%}.id           |

## Data Scructure

| Column    | Title  | ADIOS Type | Length | Required |
| --------- | ------ | ---------- | ------ | -------- |
| id        | ID     | lookup     |        | TRUE     |
| id_person | Person | lookup     |        | TRUE     |

### ADIOS parameters

### Foreign Keys

| Column    | Model                                             | Relation | OnUpdate | OnDelete |
| --------- | ------------------------------------------------- | -------- | -------- | -------- |
| id_person | [Modules\Core\Customers\Models\Person](Person.md) | 1:1      | Cascade  | Restrict |

### Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
