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
| id                 | ID           | int        | 8      | TRUE     |
| name               | Company Name | varchar    |        | TRUE     |
| id_company_address | address      | lookup     |        | FALSE    |
| email              | E-mail       | varchar    |        | FALSE    |
| phone_number       | Phone Number | varchar    |        | FALSE    |
| company_id         | Company ID   | varchar    |        | TRUE     |
| tax_id             | TAX ID       | varchar    |        | TRUE     |
| vat_id             | VAR ID       | varchar    |        | TRUE     |
| id_contact_person  | Contact      | lookup     |        | FALSE    |
| tags               | Tags         | tags       | 8      | FALSE    |
| note               | Note         | textarea   |        | FALSE    |
| is_active          | Active       | boolean    |        | TRUE     |

<strong style="color:orange">
čo teda s vat a tax? bude to aj pri person? <br> 
lebo za mňa ak osoba nie je samostatný podnikateľ, nie je nutné to pri osobe uchovávať
taktiež kontaktné informácie ..potrebuje mať Company samostatné?..pipedrive to nemá 
</strong>


## ADIOS parameters

## Foreign Keys

| Column             | Model                                               | Relation | OnUpdate | OnDelete |
| ------------------ | --------------------------------------------------- | -------- | -------- | -------- |
| id_contact_person  | [Modules\Core\Customers\Models\Person](Person.md)   | 1:N      | Cascade  | Restrict |
| id_company_address | [Modules\Core\Customers\Models\Address](Address.md) | 1:1      | Cascade  | Restrict |

## Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
| email | UNIQUE  |      email ASC |
