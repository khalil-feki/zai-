-- Fix fk_soc assignments for users
-- This script assigns company ID 1 (default company) to users who don't have fk_soc assigned
-- You can run this directly in your MySQL/phpMyAdmin

-- First, check current status
SELECT 
    COUNT(*) as total_users,
    COUNT(fk_soc) as users_with_company,
    COUNT(*) - COUNT(fk_soc) as users_without_company
FROM h8pd_user 
WHERE email IS NOT NULL;

-- Show users without company assignment
SELECT rowid, login, email, firstname, lastname, fk_soc
FROM h8pd_user 
WHERE fk_soc IS NULL AND email IS NOT NULL
LIMIT 10;

-- Option 1: Assign all users to company ID 1 (temporary solution)
-- UPDATE h8pd_user SET fk_soc = 1 WHERE fk_soc IS NULL AND email IS NOT NULL;

-- Option 2: Create individual companies for each user (better solution)
-- This requires manual execution for each user or use the PHP scripts

-- Check available companies in Dolibarr
SELECT rowid, nom as company_name, email, client
FROM h8pd_societe 
WHERE client = 1
ORDER BY rowid
LIMIT 10;

-- After running the update, verify the results
-- SELECT 
--     COUNT(*) as total_users,
--     COUNT(fk_soc) as users_with_company,
--     COUNT(*) - COUNT(fk_soc) as users_without_company
-- FROM h8pd_user 
-- WHERE email IS NOT NULL;