class CreateTinyulls < ActiveRecord::Migration
  def self.up
    create_table :tinyulls do |t|
      t.string :shorturl
      t.string :longurl

      t.timestamps
    end
  end

  def self.down
    drop_table :tinyulls
  end
end
