<form action="{{ route('users.destroy', $model->id) }}" method="POST">
  @csrf @method('DELETE')
  <a href="{{ route('users.edit', $model->id) }}" class="btn btn-xs btn-warning">edit</a>
  <button class="btn btn-xs btn-danger" onclick="return confirm('Are You sure You want to delete this user?')">delete</button>
</form>