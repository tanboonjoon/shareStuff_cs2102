class CreateUsers < ActiveRecord::Migration
  def change
    create_table :users, id: false do |t|
    	t.string :username
    	t.string :email
    	t.boolean :is_admin , :default => false

      	t.timestamps null: false
      execute %Q{ ALTER TABLE "users" ADD PRIMARY KEY ("username"); }
      
    end
  end
end
