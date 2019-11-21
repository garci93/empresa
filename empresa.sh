#!/bin/sh

psql -h localhost -U usuario -d datos < empresa.sql
