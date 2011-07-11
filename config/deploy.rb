set :user, 'adminosl'
set :group, 'adminosl'
set :domain, 'railsapps1.osl.ull.es'
set :project, 'tinyULL'
set :application, 'tinyULL'
set :applicationdir, "/var/rails/#{application}"

set :scm, :git
set :repository, "https://git.gitorious.org/mencey/tinyull.git"
set :branch, "master"

role :web, "railsapps1.osl.ull.es"                          # Your HTTP server, Apache/etc
role :app, "railsapps1.osl.ull.es"                          # This may be the same as your `Web` server
role :db,  "railsapps1.osl.ull.es", :primary => true 	    # This is where Rails migrations will run

set :deploy_to, applicationdir
set :deploy_via, :remote_cache

# additional settings
default_run_options[:pty] = true
ssh_options[:keys] = %w(~/.ssh/tinyull)
set :chmod755, "app config db public script script/* public/disp*"
set :use_sudo, false

namespace :deploy do
  task :restart do
    run "touch #{current_path}/tmp/restart.txt"
  end

  task :start do
  end

  task :stop do
  end

  desc "Link shared files"
  task :before_symlink do
    run "ln -s #{shared_path}/config/database.yml #{release_path}/config/database.yml"
  end
end
