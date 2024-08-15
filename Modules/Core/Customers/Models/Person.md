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
| urlBase         | core/customers/persons              |
| lookupSqlValue  | concat(first_name, ', ', last_name) |

## Data Scructure

| Column             | Title        | ADIOS Type | Length | Required |
| ------------------ | ------------ | ---------- | ------ | -------- |
| id_person          | ID           | int        |        | TRUE     |
| id_person_Account  | Account ID   | lookup     |        | TRUE     |
| id_person_Address  | Address ID   | lookup     |        | TRUE     |
| id_person_Contact  | Contact ID   | lookup     |        | TRUE     |
| id_contact_Company | Company ID   | lookup     |        | TRUE     |
| first_name         | First Name   | varchar    |        | TRUE     |
| last_name          | Last Name    | varchar    |        | TRUE     |
| email              | E-mail       | varchar    |        | TRUE     |
| phone_number       | Phone Number | varchar    |        | FALSE    |
| tags               | Tags         | tags       |        | FALSE    |
| note               | Note         | textarea   |        | FALSE    |
| is_active          | Active       | boolean    |        | TRUE     |

### ADIOS parameters

### Foreign Keys

| Column             | Model                                               | Relation | OnUpdate | OnDelete |
| ------------------ | --------------------------------------------------- | -------- | -------- | -------- |
| id_contact_Company | [Modules\Core\Customers\Models\Company](Company.md) | 1:N      | Cascade  | Restrict |
| id_person_Address  | [Modules\Core\Customers\Models\Address](Address.md) | 1:1      | Cascade  | Restrict |
| id_contact_Contact | [Modules\Core\Customers\Models\Company](Contact.md) | 1:N      | Cascade  | Restrict |
| id_person_Account  | [Modules\Core\Customers\Models\Address](Account.md) | 1:1      | Cascade  | Restrict |

### Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
| email | UNIQUE  |      email ASC |
