class UsersController < ApplicationController
  def index
  end
  def new
  	@user = User.new
  end

  def show
  	@user = User.find(params[:username])
  end

  def create
  	@user = User.new(user_params)
  	if @user.save
  		flash[:success] = "Welcome to our sharing website"
  		redirect_to user_url(@user)
  	else
  		render 'new'
  	end
  end
  private
  def user_params
  	params.require(:user).permit(:username, :email, :password, :password_confirmation)
  end
end
