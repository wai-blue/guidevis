# Model Contacts/Person

## Introduction

Zoznam jednotlivcov, ktorý existujú v systéme.

## Constants

## Properties

| Property        | Value                               |
| :-------------- | :---------------------------------- |
| isJunctionTable | FALSE                               |
| storeRecordInfo | FALSE                               |
| sqlName         | persons                             |
| lookupSqlValue  | concat(first_name, ', ', last_name) |

## Data Scructure

| Column                  | Title        | ADIOS Type | Length | Required |
| ----------------------- | ------------ | ---------- | ------ | -------- |
| id                      | ID           | int        | 8      | TRUE     |
| first_name              | First Name   | varchar    |        | TRUE     |
| last_name               | Last Name    | varchar    |        | TRUE     |
| street                  | Street       | varchar    |        | FALSE    |
| postal_code             | Postal code  | varchar    |        | FALSE    |
| city                    | City         | varchar    |        | FALSE    |
| email                   | E-mail       | varchar    |        | FALSE    |
| phone_number            | Phone Number | varchar    |        | FALSE    |
| company_id              | Company ID   | varchar    |        | TRUE     |
| tax_id                  | TAX ID       | varchar    |        | TRUE     |
| vat_id                  | VAR ID       | varchar    |        | TRUE     |
| tags                    | Tags         | tags       |        | FALSE    |
| id_contact_organization | Organization | lookup     |        | FALSE    |
| note                    | Note         | textarea   |        | FALSE    |
| is_active               | Active       | boolean    |        | TRUE     |

### ADIOS parameters

### Foreign Keys

| Column            | Model                                                    | Relation | OnUpdate | OnDelete |
| ----------------- | -------------------------------------------------------- | -------- | -------- | -------- |
| id_contact_person | [Modules\Core\Customers\Models\Organization](Company.md) | 1:1      | Cascade  | Restrict |

### Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
| email | UNIQUE  |      email ASC |
