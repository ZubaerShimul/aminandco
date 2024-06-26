<?php

const TENDER_STATUS_PENDING = 1;
const TENDER_STATUS_ONGOING = 2;

const CATEGORY_TYPE_EXPENSE = 'Expense';
const CATEGORY_TYPE_INCOME  = 'Income';

const EXPENSE               = 'Expense';
const INCOME                = 'Income';

const CASH_IN               = 'Cash in';
const CASH_OUT              = 'Cash out';
const ENABLE = 1;
const DISABLE = 0;

# category
const CATEGORY_ID_OPENING_BALANCE   = 1;
const CATEGORY_ID_OFFICIAL_EXPENSE  = 2;
const CATEGORY_ID_SALARY_EXPENSE    = 3;
const CATEGORY_ID_PAYMENT_INCOME    = 4;

#transactions 
const TRANSACTION_EMPLOYEE_SALARY   = 'Salary';
const TRANSACTION_EMPLOYEE_PAYMENT  = 'Payment';
const TRANSACTION_RECEIVE           = 'Receive';

# model
const MODEL_ACCOUNT = "App\Models\BankAccount";


// **************************** NEW ***************************/**
const TYPE_SITE = "Site";
const TYPE_PARTNER = "Partner";

const DOCUMENT_PATH = "uploads/documents/";

// user status

const USER_ACTIVE = 2;
const USER_DEACTIVE = 1;

const EXPENSE_TYPE_OFFICIAL = "Official Expense";
const EXPENSE_TYPE_OTHERS    = "Others Expense";