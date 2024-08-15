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

| Column       | Title        | ADIOS Type | Length | Required |
| ------------ | ------------ | ---------- | ------ | -------- |
| id_contact   | ID           | int        |        | TRUE     |
| email        | E-mail       | varchar    |        | FALSE    |
| phone_number | Phone Number | varchar    |        | FALSE    |
| website      | Website      | varchar    |        | FALSE    |
| linkedIn     | LinkedIn     | varchar    |        | FALSE    |
| fax          | Fax          | varchar    |        | FALSE    |

--Malo by sa vyriešiť čo bude required, nemôže byť všetko false a treba doplniť lookup value

### ADIOS parameters

### Foreign Keys

### Indexes

| Name       |  Type   | Column + Order |
| :--------- | :-----: | -------------: |
| id_contact | PRIMARY | id_contact ASC |
