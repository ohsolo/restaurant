<template>
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h4 class="sec_hd t_primary fw-bold mb-4 mt-4">Chat</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="chat_wrapper">
            <div class="mesgs">
              <div class="msg_history" id="msg-container">
                <template v-for="item in allMessages?.messages" :key="item.id">
                  <div class="incoming_msg" v-if="item?.to == matchID">
                    <div class="received_msg">
                      <div class="received_withd_msg">
                        <p>{{ item?.message || "" }}</p>
                        <span class="time_date">
                          {{ printTime(item.created_at) }} |
                          {{ printDate(item.created_at) }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="outgoing_msg" v-else>
                    <div class="sent_msg">
                      <p>{{ item?.message || "" }}</p>
                      <span class="time_date">
                        {{ printTime(item.created_at) }} |
                        {{ printDate(item.created_at) }}</span>
                    </div>
                  </div>
                </template>
              </div>
              <div class="type_msg">
                <div class="input_msg_write">
                  <input type="text" class="write_msg" v-model="message" required placeholder="Type a message" />
                  <button class="msg_send_btn908" type="button" @click="sendMessage">
                    <div class="icon_wrapper" v-if="!sendingMessage">
                      <fa icon="paper-plane" class="text-light" />
                    </div>
                    <div class="my_spinner spinner-border" role="status" v-else>
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
  
<script>
import { API } from "../../../axois.js";
import moment from "moment";
export default {
  name: "ChatBox",
  props: {
    sendMessageAPI: {
      type: String,
    },
    getMessageAPI: {
      type: String,
    },
    ID: {
      type: String,
    },
    matchID: {
      type: String,
    },
  },
  data() {
    return {
      message: null,
      sendingMessage: false,
      allMessages: null,
      gettingMessages: false,
    };
  },
  created() {
    this.getAllMessages();
    const call = this;
    this.$Messaging.onMessage(function (payload) {
      if (
        payload.data.is_chat != undefined &&
        payload.data.is_chat != "" &&
        payload.data.is_chat == "1"
      ) {
        call.getAllMessages();
      }
    });
  },
  methods: {
    getAllMessages() {
      this.gettingMessages = true;
      API(this, this.getMessageAPI + this.ID, "post", null)
        .then((res) => {
          this.allMessages = res?.data.response.detail;
          setTimeout(() => {
            const container = this.$el.querySelector("#msg-container");
            container.scrollTop = container.scrollHeight;
          }, 500);
          this.gettingMessages = false;
        })
        .catch((err) => {
          console.error(
            "🚀 ~ file: view-single-order.vue ~ getAllMessages ~ err",
            err
          );
          this.gettingMessages = false;
        });
    },
    sendMessage() {
      this.sendingMessage = true;
      API(this, this.sendMessageAPI + this.ID, "post", {
        message: this.message,
      })
        .then((res) => {
          let msgObj = res?.data?.response?.detail?.message;
          this.allMessages?.messages.push(msgObj);
          this.message = null;
          setTimeout(() => {
            const container = this.$el.querySelector("#msg-container");
            container.scrollTop = container.scrollHeight;
          }, 500);
          this.sendingMessage = false;
        })
        .catch((err) => {
          console.error(
            "🚀 ~ file: view-single-order.vue ~ addMessage ~ err",
            err
          );
          this.sendingMessage = false;
        });
    },
    printDate(dt) {
      if (moment(dt).format("L") == moment().format("L")) {
        return "Today";
      } else {
        return moment(dt).format("L");
      }
    },
    printTime(dt) {
      return moment(dt).format("HH:mm");
    },
  },
};
</script>
  
<style lang="scss">
.viewCard {
  .avatar {
    width: 35px;
    height: 35px;
    background-color: #ccc;
  }

  h5 {
    font-size: 0.785rem;
  }

  p {
    font-size: 0.65rem;
    margin-bottom: 0.2rem;
  }
}

.chat_wrapper {
  border: 1px solid #ff6400;
  border-radius: 12px;

  .mesgs {
    padding: 30px 15px 0 25px;
    width: 100%;

    .msg_history {
      height: 516px;
      overflow-y: auto;
      scrollbar-width: thin;
      padding: 10px;

      &::-webkit-scrollbar {
        width: 7px;
      }

      &::-webkit-scrollbar-thumb {
        background-color: #ccc;
      }

      &::-webkit-scrollbar-track {
        background-color: rgba(204, 204, 204, 0.26);
      }

      .incoming_msg {
        display: flex;

        .received_msg {
          display: inline-block;
          padding: 0 0 0 10px;
          vertical-align: top;
          width: 92%;

          .received_withd_msg {
            width: 57%;

            p {
              background: #ebebeb none repeat scroll 0 0;
              border-radius: 3px;
              color: #646464;
              font-size: 14px;
              margin: 0;
              padding: 5px 10px 5px 12px;
              width: 100%;
            }
          }
        }
      }

      .outgoing_msg {
        overflow: hidden;
        margin: 26px 0 26px;

        .sent_msg {
          float: right;
          width: 46%;

          p {
            background: #ff6400;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
          }
        }
      }

      .time_date {
        color: #747474;
        display: block;
        font-size: 10px;
        margin: 5px 0 0;
      }
    }

    .type_msg {
      border-top: 1px solid #c4c4c4;
      position: relative;

      .input_msg_write {
        input {
          background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
          border: medium none;
          color: #4c4c4c;
          font-size: 15px;
          padding: 10px 40px 10px 10px;
          width: 100%;

          &:focus {
            outline: none;
            box-shadow: unset !important;
          }
        }

        .msg_send_btn908 {
          border: none;
          background-color: transparent;
          cursor: pointer;
          position: absolute;
          right: 0;
          top: 6px;

          .icon_wrapper {
            font-size: 17px;
            border-radius: 100%;
            background: #ff6400;
            color: #fff;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
          }

          .my_spinner {
            border-right-color: #ff6400 !important;
          }
        }
      }
    }
  }

  @media (max-width: 768px) {
    .mesgs {
      padding: 20px 10px 0 16px;

      .msg_history {
        .outgoing_msg .sent_msg {
          width: 65%;
        }

        .incoming_msg {
          .incoming_msg_img {
            width: 30px;
            height: 30px;
          }

          .received_msg {
            .received_withd_msg {
              width: 90%;
            }
          }
        }
      }
    }
  }
}
</style>