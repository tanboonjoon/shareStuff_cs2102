module SessionsHelper

	def log_in(user)
		session[:user_username] = user.username
	end

	def current_user
		@current_user ||= User.find_by(id: session[:user_username])
	end

	def logged_in?
		!current_user.nil?
	end
end
