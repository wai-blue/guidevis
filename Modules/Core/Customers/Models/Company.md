# Model Contacts/Company

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

| Column            | Title        | ADIOS Type | Length | Required |
| ----------------- | ------------ | ---------- | ------ | -------- |
| id                | ID           | int        |        | TRUE     |
| id_account        | Account      | lookup     |        | TRUE     |
| id_person_contact | Person       | lookup     |        | TRUE     | Hlavný kontakt?
| name              | Company Name | varchar    |        | TRUE     |
| street            | Street       | varchar    |        | TRUE     |
| postal_code       | Postal code  | varchar    |        | TRUE     |
| city              | City         | varchar    |        | TRUE     |
| country           | Country      | varchar    |        | TRUE     |
| tags              | Tags         | tags       |        | FALSE    |
| note              | Note         | textarea   |        | FALSE    |
| is_active         | Active       | boolean    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

| Column            | Model                                               | Relation | OnUpdate | OnDelete |
| ----------------- | --------------------------------------------------- | -------- | -------- | -------- |
| id_person_contact | [Modules\Core\Customers\Models\Person](Person.md)   | 1:1      | Cascade  | Restrict |
| id_account        | [Modules\Core\Customers\Models\Account](Account.md) | 1:1      | Cascade  | Restrict |

## Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
