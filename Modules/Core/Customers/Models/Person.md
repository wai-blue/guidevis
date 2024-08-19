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

| Column       | Title        | ADIOS Type | Length | Required |
| ------------ | ------------ | ---------- | ------ | -------- |
| id           | ID           | int        |        | TRUE     |
| id_company   | Company      | lookup     |        | TRUE     |
| first_name   | First Name   | varchar    |        | TRUE     |
| last_name    | Last Name    | varchar    |        | TRUE     |
| email        | E-mail       | varchar    |        | TRUE     |
| phone_number | Phone Number | varchar    |        | FALSE    |
| is_primary   | Is Primary   | boolean    |        | TRUE     |
| tags         | Tags         | tags       |        | FALSE    |
| note         | Note         | textarea   |        | FALSE    |
| is_active    | Active       | boolean    |        | TRUE     |

### ADIOS parameters

### Foreign Keys

| Column             | Model                                               | Relation | OnUpdate | OnDelete |
| ------------------ | --------------------------------------------------- | -------- | -------- | -------- |
| id_company         | [Modules\Core\Customers\Models\Company](Company.md) | 1:1      | Cascade  | Restrict |

### Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
| email | UNIQUE  |      email ASC |
