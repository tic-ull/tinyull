class TinyullsController < ApplicationController
  # GET /tinyulls
  # GET /tinyulls.xml
  def index
    @tinyull = Tinyull.new
    if !params[:url].nil? && !params[:url].empty?
      redirect_to :action => :create, :longurl => params[:url], :html => {:method => :post}
    else 
      respond_to do |format|
        format.html # new.html.erb
      end
    end
  end

  # GET /tinyulls/1
  # GET /tinyulls/1.xml
  def show
    @tinyull = Tinyull.find_by_shorturl(params[:id])
    if @tinyull.blank? 
      redirect_to root_path
    else 
      if !params[:redirect].nil? && !params[:redirect].empty? && params[:redirect] == "no"
        respond_to do |format|
          format.html # show.html.erb
        end
      else
        headers["Status"] = "301 Moved Permanently"
        redirect_to @tinyull[:longurl]
      end
    end
  end

  # GET /tinyulls/list/all
  def list
    @tinyulls = Tinyull.all
    respond_to do |format|
      format.html # list.html.erb
    end
  end


  # POST /tinyulls
  # POST /tinyulls.xml
  def create
    if !params[:longurl].nil? && !params[:longurl].empty?
      @longurl_tmp = params[:longurl]
      @longurl_tmp.each do |tmp|
        if @longurl.nil?
          @longurl = tmp
        else
          @longurl += "/"+tmp 
        end
      end
    elsif !params[:tinyull][:longurl].nil? && !params[:tinyull][:longurl].empty?
      @longurl = params[:tinyull][:longurl]
    else
      redirect_to(root_path) and return
    end

    if !@longurl.nil? && !(@longurl =~ /https?:\/\//)
      @longurl = "http://"+@longurl
    end

    @search = Tinyull.find(:all, :conditions => ['longurl LIKE ?', "#{@longurl}"]);
    if @search.empty?
      @tinyull = Tinyull.new(:longurl => @longurl)
      if @tinyull.save
        @shorturl = @tinyull.id.to_s(36)
        @tinyull.shorturl = @shorturl
        if @tinyull.save
          if !params[:out].nil? && !params[:out].empty? 
            render :text => $domain + "/" + @tinyull.shorturl
          else
            respond_to do |format|
              format.html { render :action => "show", :id => Tinyull.id}
            end
          end
        end
      else
        if !params[:out].nil? && !params[:out].empty?
          render :text => ""
        else
          redirect_to(root_path) and return
        end
      end
    else
      @tinyull = @search[0]
      if !params[:out].nil? && !params[:out].empty?
        render :text => $domain + "/" + @search[0].shorturl
      else
        respond_to do |format|
          format.html { render :action => "show", :id => @search[0].id}
        end
      end
    end
  end

  def new
    redirect_to :action => :show, :id => 'new'
  end


  # DELETE /tinyulls/1
  # DELETE /tinyulls/1.xml
  def destroy
    @tinyull = Tinyull.find(params[:id])
    @tinyull.destroy

    respond_to do |format|
      format.html { redirect_to :action => :list }
    end
 end
end
