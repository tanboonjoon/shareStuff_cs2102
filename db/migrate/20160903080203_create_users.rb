class CreateUsers < ActiveRecord::Migration
  def change
    create_table :users, id: false do |t|
    	t.string :username
    	t.string :password
    	t.string :email
    	t.boolean :is_admin , :default => false

      	t.timestamps null: false
      /execute "ALTER TABLE USERS ADD PRIMARY KEY (username);"/
    end
  end
end
