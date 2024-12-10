import Tool from "./components/Tool";
import OpenAIResponseField from "./components/OpenAIResponseField";

Nova.booting((app, store) => {
  app.component("nova-openai", Tool);
  app.component("detail-openai-response-field", OpenAIResponseField);
});
