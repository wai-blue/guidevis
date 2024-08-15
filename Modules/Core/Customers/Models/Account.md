# Model Contacts/Account

## Introduction

Zoznam profilov, ktoré existujú v systéme.

## Constants

## Properties

| Property        | Value                  |
| :-------------- | :--------------------- |
| isJunctionTable | FALSE                  |
| storeRecordInfo | FALSE                  |
| sqlName         | cer_account            |
| urlBase         | core/customers/account |
| lookupSqlValue  | id_account             |

## Data Scructure

| Column     | Title        | ADIOS Type | Length | Required |
| ---------- | ------------ | ---------- | ------ | -------- |
| id_account | ID           | int        |        | TRUE     |
| name       | Account Name | varchar    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

## Indexes

| Name       |  Type   | Column + Order |
| :--------- | :-----: | -------------: |
| id_account | PRIMARY | id_account ASC |
