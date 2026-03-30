-- Promote Standby
STOP SLAVE;
SET GLOBAL read_only = OFF;
