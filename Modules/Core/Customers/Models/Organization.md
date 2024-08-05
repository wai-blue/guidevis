# Model Contacts/Organization

## Introduction

Zoznam organizácií, ktoré existujú v systéme.

## Constants

## Properties

| Property               | Value                                   |
| :--------------------- | :-------------------------------------- |
| isJunctionTable        | FALSE                                   |
| storeRecordInfo        | FALSE                                   |
| sqlName                | cer_organizatios                        |
| urlBase                | core/customers/organizations            |
| lookupSqlValue         | name                                    |
| tableTitle             | Organizations                           |
| formTitleForInserting  | New Organization                        |
| formTitleForEditing    | Organization                            |
| crud/browse/controller | Core/Customers/Organiziations           |
| crud/add/controller    | Core/Customers/Organiziations/Add       |
| crud/edit/controller   | Core/Customers/Organiziations/{id}/Edit |

## Data Scructure

| Column            | Title        | ADIOS Type | Length | Required | Notes                |
| ----------------- | ------------ | ---------- | ------ | -------- | -------------------- |
| id                | ID           | int        | 8      | TRUE     |                      |
| name              | Company Name | varchar    |        | TRUE     | Názov                |
| street            | Street       | varchar    |        | FALSE    | Ulica                |
| postal_code       | Postal code  | varchar    |        | FALSE    | PSČ                  |
| city              | City         | varchar    |        | FALSE    | Mesto                |
| email             | E-mail       | varchar    |        | FALSE    | E-mail               |
| phone_number      | Phone Number | varchar    |        | FALSE    | Primárne tel. č.     |
| company_id        | Company ID   | varchar    |        | TRUE     | IČO                  |
| tax_id            | TAX ID       | varchar    |        | TRUE     | DIČ                  |
| vat_id            | VAR ID       | varchar    |        | TRUE     | IČ DPH               |
| id_contact_person | Contact      | lookup     |        | FALSE    | ID kontaktnej osoby  |
| tags              | Tags         | tags       | 8      | FALSE    | Značky               |
| note              | Note         | textarea   |        | FALSE    | Poznámky             |
| is_active         | Active       | boolean    |        | TRUE     | Aktívna organizácia? |

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
