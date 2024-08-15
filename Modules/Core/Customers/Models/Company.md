# Model Contacts/Company

## Introduction

Zoznam firiem, ktoré existujú v systéme.

## Constants

## Properties

| Property        | Value                  |
| :-------------- | :--------------------- |
| isJunctionTable | FALSE                  |
| storeRecordInfo | FALSE                  |
| sqlName         | cer_company            |
| urlBase         | core/customers/company |
| lookupSqlValue  | name                   |

## Data Scructure

| Column             | Title        | ADIOS Type | Length | Required |
| ------------------ | ------------ | ---------- | ------ | -------- |
| id_company         | ID           | int        |        | TRUE     |
| id_contact_person  | Person ID    | lookup     |        | TRUE     |
| id_contact_account | Account ID   | lookup     |        | TRUE     |
| name               | Company Name | varchar    |        | TRUE     |
| street             | Street       | varchar    |        | TRUE     |
| postal_code        | Postal code  | varchar    |        | TRUE     |
| city               | City         | varchar    |        | TRUE     |
| country            | Country      | varchar    |        | TRUE     |
| tags               | Tags         | tags       |        | FALSE    |
| note               | Note         | textarea   |        | FALSE    |
| is_active          | Active       | boolean    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

| Column             | Model                                               | Relation | OnUpdate | OnDelete |
| ------------------ | --------------------------------------------------- | -------- | -------- | -------- |
| id_contact_person  | [Modules\Core\Customers\Models\Person](Person.md)   | 1:N      | Cascade  | Restrict |

## Indexes

| Name       |  Type   | Column + Order |
| :--------- | :-----: | -------------: |
| id_company | PRIMARY |         id ASC |
