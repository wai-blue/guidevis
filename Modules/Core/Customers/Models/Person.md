# Model Contacts/Person

## Introduction

Zoznam jednotlivcov, ktorý existujú v systéme.

## Constants

## Properties

| Property               | Value                               |
| :--------------------- | :---------------------------------- |
| isJunctionTable        | FALSE                               |
| storeRecordInfo        | FALSE                               |
| sqlName                | cer_persons                         |
| urlBase                | core/customers/persons              |
| lookupSqlValue         | concat(first_name, ', ', last_name) |
| tableTitle             | Persons                             |
| formTitleForInserting  | New Person                          |
| formTitleForEditing    | Person                              |
| crud/browse/controller | Core/Customers/Persons              |
| crud/add/controller    | Core/Customers/Persons/Add          |
| crud/edit/controller   | Core/Customers/Persons/{id}/Edit    |

## Data Scructure

| Column                  | Title        | ADIOS Type | Length | Required | Notes                     |
| ----------------------- | ------------ | ---------- | ------ | -------- | ------------------------- |
| id                      | ID           | int        | 8      | TRUE     |                           |
| first_name              | First Name   | varchar    |        | TRUE     | Meno                      |
| last_name               | Last Name    | varchar    |        | TRUE     | Priezvisko                |
| street                  | Street       | varchar    |        | FALSE    | Ulica                     |
| postal_code             | Postal code  | varchar    |        | FALSE    | PSČ                       |
| city                    | City         | varchar    |        | FALSE    | Mesto                     |
| email                   | E-mail       | varchar    |        | FALSE    | E-mail                    |
| phone_number            | Phone Number | varchar    |        | FALSE    | Telefónne číslo           |
| company_id              | Company ID   | varchar    |        | TRUE     | IČO                       |
| tax_id                  | TAX ID       | varchar    |        | TRUE     | DIČ                       |
| vat_id                  | VAR ID       | varchar    |        | TRUE     | IČ DPH                    |
| tags                    | Tags         | tags       |        | FALSE    | Značky                    |
| id_contact_organization | Organization | lookup     |        | FALSE    | ID príslušnej organizácie |
| note                    | Note         | textarea   |        | FALSE    | Poznámka                  |
| is_active               | Active       | boolean    |        | TRUE     | Aktívny Kontakt?          |

### ADIOS parameters

### Foreign Keys

| Column            | Model                                                         | Relation | OnUpdate | OnDelete |
| ----------------- | ------------------------------------------------------------- | -------- | -------- | -------- |
| id_contact_person | [Modules\Core\Customers\Models\Organization](Organization.md) | 1:1      | Cascade  | Restrict |

### Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
| email | UNIQUE  |      email ASC |
