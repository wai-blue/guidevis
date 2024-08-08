# Model Contacts/contact

## Introduction

Zoznam kontaktných informácií.

## Constants

## Properties

| Property        | Value    |
| :-------------- | :------- |
| isJunctionTable | FALSE    |
| storeRecordInfo | FALSE    |
| sqlName         | contacts |
| lookupSqlValue  |          |

## ENUMERATION Data Scructure

| Column             | Title        | ADIOS Type | Length | Required |
| ------------------ | ------------ | ---------- | ------ | -------- |
| id                 | ID           | int        | 8      | TRUE     |
| id_contact_Company | Company ID   | varchar    |        | TRUE     |
| id_person          | Person ID    | varchar    |        | TRUE     |
| email              | E-mail       | varchar    |        | FALSE    |
| phone_number       | Phone Number | varchar    |        | FALSE    |
| website            | Website      | varchar    |        | FALSE    |
| linkedIn           | LinkedIn     | varchar    |        | FALSE    |

<strong style="color:orange">
Nedá sa to vytvoriť ako additional contact info alebo niečo podobné<br>
kde by sa zvolila jedna vec z enumu ?
</strong>

### ADIOS parameters

### Foreign Keys

| Column     | Model                                               | Relation | OnUpdate | OnDelete |
| ---------- | --------------------------------------------------- | -------- | -------- | -------- |
| id_company | [Modules\Core\Customers\Models\Company](Company.md) | 1:1      | Cascade  | Restrict |
| id_person  | [Modules\Core\Customers\Models\Person](Person.md)   | 1:1      | Cascade  | Restrict |

### Indexes

| Name  |  Type   | Column + Order |
| :---- | :-----: | -------------: |
| id    | PRIMARY |         id ASC |
| email | UNIQUE  |      email ASC |
