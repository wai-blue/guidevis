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

| Column             | Title        | ADIOS Type | Length | Required |
| ------------------ | ------------ | ---------- | ------ | -------- |
| id                 | ID           | int        | 8      | TRUE     |
| id_person_Address  | Address      | lookup     |        | FALSE    |
| id_contact_Company | Company      | lookup     |        | FALSE    |
| first_name         | First Name   | varchar    |        | TRUE     |
| last_name          | Last Name    | varchar    |        | TRUE     |
| email              | E-mail       | varchar    |        | FALSE    |
| phone_number       | Phone Number | varchar    |        | FALSE    |
| tags               | Tags         | tags       |        | FALSE    |
| note               | Note         | textarea   |        | FALSE    |
| is_active          | Active       | boolean    |        | TRUE     |

### ADIOS parameters

### Foreign Keys

| Column             | Model                                               | Relation | OnUpdate | OnDelete |
| ------------------ | --------------------------------------------------- | -------- | -------- | -------- |
| id_contact_Company | [Modules\Core\Customers\Models\Company](Company.md) | 1:1      | Cascade  | Restrict |
| id_person_Address  | [Modules\Core\Customers\Models\Address](Address.md) | 1:1      | Cascade  | Restrict |

### Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
| email | UNIQUE  |      email ASC |
