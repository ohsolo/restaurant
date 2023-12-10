<template>
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h2 class="sec_hd t_primary fw-bold mb-4 mt-4">Chat</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-12">
          <div class="row">
            <div class="col-md-6 col-lg-12 mb-3">
              <div class="card px-3 py-3 viewCard h-100">
                <h5 class="t_primary">Restuarant</h5>
                <div class="d-flex w-100">
                  <div class="az_left">
                    <div class="img_wrapper overflow-hidden rounded-circle">
                      <img src="" alt="" class="w-100 h-100" />
                    </div>
                  </div>
                  <div class="az_right ps-2 pt-2">
                    <h6>Burger's</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-12 mb-3">
              <div class="card px-3 py-3 viewCard h-100">
                <h5 class="t_primary">Rider</h5>
                <div class="d-flex w-100">
                  <div class="az_left">
                    <div class="img_wrapper overflow-hidden rounded-circle">
                      <img src="" alt="" class="w-100 h-100" />
                    </div>
                  </div>
                  <div class="az_right ps-2 pt-2">
                    <h6>Test Rider</h6>
                    <small class="d-block"
                      >Vehicle : <fa icon="bicycle" class="t_primary fw-bold"
                    /></small>
                    <small class="d-block"
                      >Phone :
                      <span class="t_primary fw-bold"
                        >(12) 99139-4497</span
                      ></small
                    >
                    <small class="d-block"
                      >Region Of Opertaion :
                      <span class="t_primary fw-bold">Sindh</span></small
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="chat_wrapper">
            <div class="mesgs">
              <div class="msg_history">
                <div class="incoming_msg">
                  <div class="incoming_msg_img">
                    <img src="../../../assets/images/user-profile.png" />
                  </div>
                  <div class="received_msg">
                    <div class="received_withd_msg">
                      <p>Test which is a new approach to have all solutions</p>
                      <span class="time_date"> 11:01 AM | June 9</span>
                    </div>
                  </div>
                </div>
                <div class="outgoing_msg">
                  <div class="sent_msg">
                    <p>Test which is a new approach to have all solutions</p>
                    <span class="time_date"> 11:01 AM | June 9</span>
                  </div>
                </div>
                <div class="incoming_msg">
                  <div class="incoming_msg_img">
                    <img src="../../../assets/images/user-profile.png" />
                  </div>
                  <div class="received_msg">
                    <div class="received_withd_msg">
                      <p>Test, which is a new approach to have</p>
                      <span class="time_date"> 11:01 AM | Yesterday</span>
                    </div>
                  </div>
                </div>
                <div class="outgoing_msg">
                  <div class="sent_msg">
                    <p>Apollo University, Delhi, India Test</p>
                    <span class="time_date"> 11:01 AM | Today</span>
                  </div>
                </div>
                <div class="incoming_msg">
                  <div class="incoming_msg_img">
                    <img src="../../../assets/images/user-profile.png" />
                  </div>
                  <div class="received_msg">
                    <div class="received_withd_msg">
                      <p>
                        We work directly with our designers and suppliers, and
                        sell direct to you, which means quality, exclusive
                        products, at a price anyone can afford.
                      </p>
                      <span class="time_date"> 11:01 AM | Today</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="type_msg">
                <div class="input_msg_write">
                  <input
                    type="text"
                    class="write_msg"
                    placeholder="Type a message"
                  />
                  <button class="msg_send_btn" type="button">
                    <fa icon="paper-plane" class="text-light" />
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
export default {
  name: "ChatView",
  title: "Chat || Dashboard",
};
</script>

<style lang="scss">
.viewCard {
  .az_left {
    .img_wrapper {
      width: 60px;
      height: 60px;
      background-color: #ccc;
    }
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
      .incoming_msg {
        display: flex;
        .incoming_msg_img {
          display: inline-block;
          width: 40px;
          height: 40px;
          border-radius: 50%;
          overflow: hidden;
          img {
            width: 100%;
            height: 100%;
          }
        }
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
        .msg_send_btn {
          background: #ff6400;
          border: medium none;
          border-radius: 50%;
          color: #fff;
          cursor: pointer;
          font-size: 17px;
          position: absolute;
          right: 0;
          top: 6px;
          width: 30px;
          height: 30px;
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