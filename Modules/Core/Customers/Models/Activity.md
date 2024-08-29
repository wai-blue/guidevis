# Model Contacts/Activity

## Introduction

Zoznam aktivít, ktoré môžeme vytvoriť v systéme.

## Constants

## Properties

| Property        | Value                   |
| :-------------- | :---------------------- |
| isJunctionTable | FALSE                   |
| sqlName         | companies               |
| urlBase         | core/customers/activity |
| lookupSqlValue  | {%TABLE%}.id          |

## Data Scructure

| Column    | Title            | ADIOS Type | Length | Required | Additonal                                                                       |
| --------- | ---------------- | ---------- | ------ | -------- | ------------------------------------------------------------------------------- |
| id        | ID               | int        |        | TRUE     |                                                                                 |
| type      | Activity type    | varchar    |        | TRUE     | enum_values: [custom => Custom, task => Task, meeting => Meeting, call => Call] |
| subject   | Activity subject | varchar    |        | TRUE     |                                                                                 |
| due_date  | Due date         |            |        | TRUE     |                                                                                 |
| due_time  | Due time         |            |        | TRUE     |                                                                                 |
| duration  | Duration         | varchar    |        | TRUE     |                                                                                 |
| completed | Completed        | boolean    |        | TRUE     |                                                                                 |


## ADIOS parameters

## Foreign Keys

| Column            | Model                                               | Relation | OnUpdate | OnDelete |
| ----------------- | --------------------------------------------------- | -------- | -------- | -------- |


## Indexes

| Name |  Type   | Column + Order |
| :--- | :-----: | -------------: |
| id   | PRIMARY |         id ASC |
