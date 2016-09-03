class UsersController < ApplicationController

  def edit
    @user = Users.find(params[:username])
  end

  def delete
    @users = Users.all

  end

  def destroy
    @users = Users.all
    @user = Users.find(params[:username])
    @user.destroy

  end

  def index
    @users = User.all
  end


  def new
  	@user = User.new
  end

  def show
  	@user = User.find(params[:username])
  end


  def update
    @users = Users.all
    @user = User.find(params[:username])
    @user.update_attribute(user_params)
  end

  def create
     @user = User.new(user_params)
     if @user.save
      log_in @user
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

