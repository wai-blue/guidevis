# Model Contacts/Service

## Introduction

## Constants

## Properties

| Property        | Value            |
| :-------------- | :--------------- |
| isJunctionTable | FALSE            |
| sqlName         | billing_accounts |
| lookupSqlValue  | {%TABLE%}.id     |

## Data Scructure

| Column | Title | ADIOS Type | Length | Required |
| ------ | ----- | ---------- | ------ | -------- |
| id     | ID    | int        |        | TRUE     |
| name   | Name  | varchar    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

## Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
