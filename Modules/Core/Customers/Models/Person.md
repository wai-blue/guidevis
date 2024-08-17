# Model Contacts/Person

## Introduction

Zoznam jednotlivcov, ktorý existujú v systéme.

## Constants

## Properties

| Property        | Value                                                   |
| :-------------- | :------------------------------------------------------ |
| isJunctionTable | FALSE                                                   |
| sqlName         | persons                                                 |
| urlBase         | core/customers/persons                                  |
| lookupSqlValue  | concat({%TABLE%}.first_name, ', ', {%TABLE%}.last_name) |

## Data Scructure

| Column            | Title        | ADIOS Type | Length | Required |
| ----------------- | ------------ | ---------- | ------ | -------- |
| id                | ID           | int        |        | TRUE     |
| id_account        | Account      | lookup     |        | TRUE     |
| id_company        | Company      | lookup     |        | TRUE     |
| id_person_Contact | Contact ID   | lookup     |        | TRUE     | Hlavný kontakt? |
| id_person_Address | Address ID   | lookup     |        | TRUE     | Hlavná adresa?   |
| first_name        | First Name   | varchar    |        | TRUE     |
| last_name         | Last Name    | varchar    |        | TRUE     |
| email             | E-mail       | varchar    |        | TRUE     |
| phone_number      | Phone Number | varchar    |        | FALSE    |
| tags              | Tags         | tags       |        | FALSE    |
| note              | Note         | textarea   |        | FALSE    |
| is_active         | Active       | boolean    |        | TRUE     |

### ADIOS parameters

### Foreign Keys

| Column             | Model                                               | Relation | OnUpdate | OnDelete |
| ------------------ | --------------------------------------------------- | -------- | -------- | -------- |
| id_account         | [Modules\Core\Customers\Models\Account](Account.md) | 1:1      | Cascade  | Restrict |
| id_person_Address  | [Modules\Core\Customers\Models\Address](Address.md) | 1:1      | Cascade  | Restrict | Hlavná adresa?   |
| id_contact_Contact | [Modules\Core\Customers\Models\Company](Contact.md) | 1:N      | Cascade  | Restrict | Hlavný kontakt? |
| id_company         | [Modules\Core\Customers\Models\Company](Company.md) | 1:1      | Cascade  | Restrict |

### Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
| email | UNIQUE  |      email ASC |
