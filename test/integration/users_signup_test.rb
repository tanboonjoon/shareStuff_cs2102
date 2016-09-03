require 'test_helper'

class UsersSignupTest < ActionDispatch::IntegrationTest
  # test "the truth" do
  #   assert true
  # end3

  test "invalid signup info " do
  	get signup_path
  	assert_no_difference 'User.count' do
  		post users_path, user: {username: "",
  			email: "invalid@gmail.com",
  			password: "haha"}
  		end
  		assert_template 'users/new'
  end

  test "valid sign up" do
  	get signup_path
  	assert_difference 'User.count',  1 do
  		post_via_redirect users_path, user: {username: "example",
  			email: "example@gmail.com",
  			password: "1234567" }
  		end
  		assert_template 'users/show'
  end






end
