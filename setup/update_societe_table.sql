-- Add authentication fields to h8pd_societe table if they don't exist
ALTER TABLE h8pd_societe 
ADD COLUMN IF NOT EXISTS firstname VARCHAR(50) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS lastname VARCHAR(50) DEFAULT NULL;

-- Create index for better performance
CREATE INDEX IF NOT EXISTS idx_h8pd_societe_email ON h8pd_societe(email);

-- Make sure h8pd_societe_extrafields table exists
CREATE TABLE IF NOT EXISTS h8pd_societe_extrafields (
  rowid int(11) NOT NULL AUTO_INCREMENT,
  tms timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  fk_object int(11) NOT NULL,
  import_key varchar(14) DEFAULT NULL,
  pass_crypted varchar(128) DEFAULT NULL,
  PRIMARY KEY (rowid),
  KEY idx_societe_extrafields_fk_object (fk_object)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Add constraint between h8pd_societe and h8pd_societe_extrafields
ALTER TABLE h8pd_societe_extrafields
ADD CONSTRAINT IF NOT EXISTS fk_societe_extrafields_fk_object FOREIGN KEY (fk_object) REFERENCES h8pd_societe(rowid) ON DELETE CASCADE;

-- Remove the fk_user column from h8pd_societe as we're not using h8pd_user anymore
ALTER TABLE h8pd_societe DROP COLUMN IF EXISTS fk_user;