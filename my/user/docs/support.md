在Laravel 中有个support目录

在 {{programming phoenix}}一书中：
...
To do so, we need to be able to rapidly create video and user records to support our tests.
...

~~~ ex
    
    # testing_mvc/listings/rumbl/test/support/test_helpers.ex
    defmodule Rumbl.TestHelpers do
    alias Rumbl.Repo
    
    def insert_user(attrs \\ %{}) do
        changes = Dict.merge(%{
            name: "Some User",
            username: "user#{Base.encode16(:crypto.rand_bytes(8))}",
            password: "supersecret",
            }, attrs)
        %Rumbl.User{}
        |>Rumbl.User.registration_changeset(changes)
        |> Repo.insert!()
    end
    
    def insert_video(user, attrs \\ %{}) do
    user 
    |> Ecto.build_assoc(:videos, attrs)
    |> Repo.insert!()
    end
    end

~~~