# Generate text with GPT in TinyMCE

The OpenAI API provides developers with access to state-of-the-art AI models that can be integrated into their applications. 

The Boilerplate package simplifies the process of using the OpenAI API by providing a convenient interface for making requests and handling responses through a button in TinyMCE.

<img :src="$withBase('/assets/img/gpt02.png')" alt="GPT 02" style="max-width:700px">

## Configuration

You will need an OpenAI API key. To obtain one, go to https://platform.openai.com/signup and either log in or create a new account.

Next, create a new API secret key at https://platform.openai.com/account/api-keys.

Add the generated secret key in your `.env` file:

```
OPENAI_API_KEY=[place api secret here]
```

Now, the button will be available in TinyMCE

<img :src="$withBase('/assets/img/gpt01.png')" alt="GPT 01">

### Organization (optional)

For users who belong to multiple organizations, you can pass a header to specify which organization to use for an API request. Usage from these API requests will count against the specified organization's subscription quota.

To set your organization, simply add it to your `.env` file:

```
OPENAI_API_ORGANIZATION=[place your organisation key here]
```

### Model

By default, the used model is `gpt-3.5-turbo`, but you can set another model in the `boilerplate\config\app.php` file.  