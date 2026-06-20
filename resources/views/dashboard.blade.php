<h1>dashboard</h1>
<form action=" {{ route('logout') }} " method="POST" style="margin-top: 20px;">
    @csrf
    <button type="submit" style="padding: 8px 16px; background-color: #f87171; color: white; border: none; border-radius: 4px; cursor: pointer;">
        Logout
    </button>
</form>