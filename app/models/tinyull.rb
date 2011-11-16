class Tinyull < ActiveRecord::Base
	validates_presence_of :longurl
	validates_format_of   :longurl, :with => /^(http:\/\/|https:\/\/|\w*[^:]\w)[^&\?\/]+\.ull\.es(\/\S*$|\?\S*$|$)/i
end
