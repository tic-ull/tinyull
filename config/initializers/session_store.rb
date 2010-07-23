# Be sure to restart your server when you modify this file.

# Your secret key for verifying cookie session data integrity.
# If you change this key, all old sessions will become invalid!
# Make sure the secret is at least 30 characters and all random, 
# no regular words or you'll be exposed to dictionary attacks.
ActionController::Base.session = {
  :key         => '_tinyull_session',
  :secret      => '5f7807d5edd2f23573c14bbb1e2ea060e0463bb6391f769bda7192f3075f9798b217b60f4c0dad4f6c5d2c4e5820dcfe931e6d66d226f6d0f0db33e5786c5b90'
}

# Use the database for sessions instead of the cookie-based default,
# which shouldn't be used to store highly confidential information
# (create the session table with "rake db:sessions:create")
# ActionController::Base.session_store = :active_record_store
