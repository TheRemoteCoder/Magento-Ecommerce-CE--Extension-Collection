# Magento - Customer logic

Customer IDs are always ID=1, never ID=0 (NOT_LOGGED_IN). This was tested with and without old session data. Maybe this is a system preset or some kind of bug.

So you cannot check for the group only. Good thing is, group ID=1 is not used for this payment method and Wholesale customer IDs are >1.

