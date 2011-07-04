# Filters added to this controller apply to all controllers in the application.
# Likewise, all the methods added will be available for all controllers.

class ApplicationController < ActionController::Base
  before_filter :get_domain
  helper :all # include all helpers, all the time
  protect_from_forgery # See ActionController::RequestForgeryProtection for details

  # Scrub sensitive parameters from your log
  # filter_parameter_logging :password

  def get_domain
    $domain = request.subdomains.join(".") + "." + request.domain if !request.domain.nil?
    $domain = request.domain if request.subdomains.join(".") == ""
  end

end
