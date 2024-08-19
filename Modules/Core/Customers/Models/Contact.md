# Model Contacts/Contact

## Introduction

Zoznam kontaktných informácií.

## Constants

## Properties

| Property        | Value                           |
| :-------------- | :------------------------------ |
| isJunctionTable | FALSE                           |
| sqlName         | persons_contacts                |
| urlBase         | core/customers/persons-contacts |
| lookupSqlValue  | {%TABLE%}.value                 |

## Data Scructure

| Column    | Title        | ADIOS Type | Length | Required | Additional parameters                            |
| --------- | ------------ | ---------- | ------ | -------- | ------------------------------------------------ |
| id        | ID           | int        |        | TRUE     |                                                  |
| id_person | Person       | lookup     |        | TRUE     |                                                  |
| type      | Contact type | varchar    |        | TRUE     |enum_values: [email => Email, phone_number => Phone Number, website => Website, linkedid => LinkedIn, fax => Fax,...] |
| value     | Value        | varchar    |        | TRUE     |                                                  |
|           |              |            |        |          |                                                  |

### ADIOS parameters

### Foreign Keys

### Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
