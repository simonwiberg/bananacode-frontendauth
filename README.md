# bananacode-frontendauth
This is a simple Magento module that provides a few features for controlling access to the frontend of Magento. It was made
to be a simple tool for protecting staging sites or sites in development from outside visitors. In the first version there 
are three features

1. access control by admin login - if this is enabled users logged in to admin will be granted access also to front-end
2. whitelisting of remote hosts - if this is enabled users with ip on whitelist will be granted access, whitelist is 
configured from system configuration
3. just for the fun of it, I also added the possbility of blacklisting hosts

An answer provided by Sander Mangel on this question on stackexchange provided a good starting point for this weekend project
http://magento.stackexchange.com/questions/15361/password-protection
