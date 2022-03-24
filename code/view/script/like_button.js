"use strict";

const e = React.createElement;

class LikeButton extends React.Component {
  constructor(props) {
    super(props);
    this.state = { liked: false };
  }

  render() {
    const name = this.props.name;
    if (this.state.liked) {
      return "You liked this.";
    }

    return e(
      "button",
      { onClick: () => this.setState({ liked: true }) },
      { name }
    );
  }
}

const domContainer = document.querySelector("#like");
const element = <LikeButton name="rafi" />;
ReactDOM.render(element, domContainer);