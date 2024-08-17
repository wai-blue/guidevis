# Model Contacts/Account

## Introduction

Zoznam profilov, ktoré existujú v systéme.

## Constants

## Properties

| Property        | Value                  |
| :-------------- | :--------------------- |
| isJunctionTable | FALSE                  |
| sqlName         | accounts               |
| urlBase         | core/customers/account |
| lookupSqlValue  | {%TABLE%}.name         |

## Data Scructure

| Column | Title        | ADIOS Type | Length | Required |
| ------ | ------------ | ---------- | ------ | -------- |
| id     | ID           | int        |        | TRUE     |
| name   | Account Name | varchar    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

## Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
