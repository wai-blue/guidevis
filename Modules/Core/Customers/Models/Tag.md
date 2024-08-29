# Model Customers/Tag

## Introduction

## Constants

## Properties

| Property        | Value              |
| :-------------- | :----------------- |
| isJunctionTable | FALSE              |
| sqlName         |                    |
| urlBase         | core/customers/tag |
| lookupSqlValue  | {%TABLE%}.id       |

## Data Scructure

| Column | Title | ADIOS Type | Length | Required |
| ------ | ----- | ---------- | ------ | -------- |
| id     | ID    | int        |        | TRUE     |
| tag    | Tag   | varchar    |        | TRUE     |

### ADIOS parameters

### Foreign Keys

### Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
