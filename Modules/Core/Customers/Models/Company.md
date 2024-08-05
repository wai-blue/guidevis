# Model Contacts/Organization

## Introduction

Zoznam firiem, ktoré existujú v systéme.

## Constants

## Properties

| Property               | Value                                   |
| :--------------------- | :-------------------------------------- |
| isJunctionTable        | FALSE                                   |
| storeRecordInfo        | FALSE                                   |
| sqlName                | cer_organizatios                        |
| urlBase                | core/customers/organizations            |
| lookupSqlValue         | name                                    |

## Data Scructure

| Column            | Title        | ADIOS Type | Length | Required |
| ----------------- | ------------ | ---------- | ------ | -------- |
| id                | ID           | int        | 8      | TRUE     |
| name              | Company Name | varchar    |        | TRUE     |
| street            | Street       | varchar    |        | FALSE    |
| postal_code       | Postal code  | varchar    |        | FALSE    |
| city              | City         | varchar    |        | FALSE    |
| email             | E-mail       | varchar    |        | FALSE    |
| phone_number      | Phone Number | varchar    |        | FALSE    |
| company_id        | Company ID   | varchar    |        | TRUE     |
| tax_id            | TAX ID       | varchar    |        | TRUE     |
| vat_id            | VAR ID       | varchar    |        | TRUE     |
| id_contact_person | Contact      | lookup     |        | FALSE    |
| tags              | Tags         | tags       | 8      | FALSE    |
| note              | Note         | textarea   |        | FALSE    |
| is_active         | Active       | boolean    |        | TRUE     |

## ADIOS parameters

## Foreign Keys

| Column            | Model                                             | Relation | OnUpdate | OnDelete |
| ----------------- | ------------------------------------------------- | -------- | -------- | -------- |
| id_contact_person | [Modules\Core\Customers\Models\Person](Person.md) | 1:N      | Cascade  | Restrict |

## Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
| email | UNIQUE  |      email ASC |
