require 'test_helper'

class UserTest < ActiveSupport::TestCase
  # test "the truth" do
  #   assert true
  # end

  def setup
  	@user = User.new(username: "Example User", password: "123456", email: "user@example.com"
  		)
  end

  test "should be valid" do
  	assert @user.valid?


  end

  test "name should be present" do
  	@user.username = "    "
  	assert_not @user.valid?
  end

  test "name should not be too long" do
  	@user.username = "a" * 51
  	assert_not @user.valid?
  end
  test "email should not be too long " do
  	@user.email = "a" * 244 + "@example.com"
  	assert_not @user.valid?
  end

  test "valid email" do
  	valid_ad = %w[user@example.com USER@foo.com A_US-ER@foo.bar.org
  		first.last@foo.jp alice+bob@baz.cn]
  	valid_ad.each do |x|
  	@user.email = x
  	assert @user.valid?, "#{x.inspect} should be valid"
  end
  end

  test "username should be unique" do
  	duplicate_user = @user.dup
  	duplicate_user.username = @user.username.upcase
  	@user.save
  	assert_not duplicate_user.valid?
  end

  test "password min leng" do
  	@user.password = @user.password = "a" * 5
  	assert_not @user.valid?
  end
end
