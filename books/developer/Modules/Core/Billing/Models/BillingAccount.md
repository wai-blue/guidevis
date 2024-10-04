# Model Contacts/BillingAccount

## Introduction

## Constants

## Properties

| Property        | Value            |
| :-------------- | :--------------- |
| isJunctionTable | FALSE            |
| sqlName         | billing_accounts |
| lookupSqlValue  | {%TABLE%}.id     |

## Data Scructure

| Column      | Title       | ADIOS Type | Length | Required |
| ----------- | ----------- | ---------- | ------ | -------- |
| id          | ID          | int        |        | TRUE     |
| id_company  | Company     | lookup     |        | TRUE     |
| description | Description | varchar    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

## Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
